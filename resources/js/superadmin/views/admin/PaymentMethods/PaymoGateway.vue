<template>
	<a-form layout="vertical">
		<div class="mb-20">
			<a-alert v-if="errorText != ''" :message="errorText" type="error" />
		</div>

		<a-row :gutter="16">
			<a-col :xs="14" :sm="14" :md="14" :lg="14">
				<a-form-item :label="$t('payment_settings.paymo_customer_card')" name="cardNumber"
					:help="rules.cardNumber ? rules.cardNumber.message : null"
					:validateStatus="rules.cardNumber ? 'error' : null" class="required">
					<a-input :disabled="CardReadonly" v-model:value="formData.cardNumber" v-mask="maskCardNumber"
						:value="maskValue" :placeholder="$t('common.placeholder_default_text', [
								$t('payment_settings.paymo_customer_card'),
							])
							" />
				</a-form-item>
			</a-col>
			<a-col :xs="10" :sm="10" :md="10" :lg="10">
				<a-form-item :label="$t('payment_settings.paymo_customer_card_expires')" name="expirationDate"
					:help="rules.expirationDate ? rules.expirationDate.message : null"
					:validateStatus="rules.expirationDate ? 'error' : null" class="required">
					<a-input :disabled="CardReadonly" v-model:value="formData.expirationDate" v-mask="maskCardYear"
						:value="maskValue" :placeholder="'mm/YY'" />
				</a-form-item>
			</a-col>
		</a-row>

		<a-row :gutter="16" class="mt-20" v-if="!finishButton">
			<a-col :xs="24" :sm="24" :md="24" :lg="24">
				<a-button type="primary" :disabled="CardReadonly" @click="pay" :loading="loading" block>
					{{ $t("payment_settings.complete_transcation") }}
				</a-button>
			</a-col>
		</a-row>

		<div class="mb-10">
			<a-alert v-if="CardMessage != ''" :message="CardMessage" type="warning" />
		</div>


		<!-- <div class="mb-20">
			<a-alert v-if="!CardStatus" :message="$t('payment_settings.bind_card_text')" type="warning" />
		</div>

		<a-row :gutter="16" v-if="!CardStatus">
			<a-col :xs="14" :sm="14" :md="14" :lg="14">
				<a-form-item :label="$t('payment_settings.verification_code_bind_card')" name="verification_code"
					:help="rules.verification_code ? rules.verification_code.message : null"
					:validateStatus="rules.verification_code ? 'error' : null" class="required">
					<a-input v-model:value="otpCode.verification_code" v-mask="maskBindOtp" :value="maskValue" :placeholder="$t('common.placeholder_default_text', [
							$t('payment_settings.verification_code_bind_card'),
						])
						" />
				</a-form-item>
			</a-col>
			<a-col :xs="10" :sm="10" :md="10" :lg="10">
				<a-form-item label="ㅤ" name="bind_otp">
					<a-button type="primary" @click="BindSuccess" :loading="loading" block>
						{{ $t("payment_settings.confirm_bind_card") }}
					</a-button>
				</a-form-item>
			</a-col>
		</a-row> -->


		<a-row :gutter="16" v-if="finishButton">
			<a-col :xs="24" :sm="24" :md="24" :lg="24">
				<a-form-item :label="$t('payment_settings.verification_code_bind_card')" name="otp"
					:help="rules.otp ? rules.otp.message : null" :validateStatus="rules.otp ? 'error' : null"
					class="required">
					<a-input v-model:value="transOtp.otp" v-mask="maskotpCode" :value="maskValue" :placeholder="$t('common.placeholder_default_text', [
							$t('payment_settings.verification_code_bind_card'),
						])
						" />
				</a-form-item>
			</a-col>
		</a-row>

		<a-row :gutter="16" class="mt-20" v-if="finishButton">
			<a-col :xs="24" :sm="24" :md="24" :lg="24">
				<a-button type="primary" @click="confirmPAymo" :loading="loading" block>
					{{ $t("payment_settings.finish_transcation") }}
				</a-button>
			</a-col>
		</a-row>

		<!-- <input type="text" v-mask="mask" :value="value"> -->

	</a-form>
</template>

<script>
import { defineComponent, ref, onBeforeMount } from "vue";
import { StripeElements, StripeElement } from "vue-stripe-js";
import { loadStripe } from "@stripe/stripe-js";
import { useI18n } from "vue-i18n";
import { message } from "ant-design-vue";
import { useStore } from "vuex";
import swal from 'sweetalert';

import common from "../../../../common/composable/common";

export default {
	props: ["paymentMethod", "subscribePlan", "planType"],
	components: {
		StripeElements,
		StripeElement
	},
	setup(props, { emit }) {
		const { t } = useI18n();
		const store = useStore();
		const { appSetting } = common();
		const paymoKey = ref(props.paymentMethod.credentials.paymo_api_key);
		const instanceOptions = ref({});
		const elementsOptions = ref({});
		const maskValue = ref('');
		const finishButton = ref(false);
		const maskCardNumber = ref('{{9999}} {{9999}} {{9999}} {{9999}}');
		const maskCardYear = ref('{{99}}/{{99}}');
		const maskotpCode = ref('{{999999}}');
		const maskBindOtp = ref('{{999999}}');
		const CardStatus = ref(true);
		const CardMessage = '';
		const CardReadonly = ref(false);
		const cardOptions = ref({
			value: {
				postalCode: "",
			},
		});
		const paymoLoaded = ref(false);
		const card = ref(null);
		const elms = ref(null);
		const formData = ref({
			cardNumber: "",
			expirationDate: "",
			plan_id: props.subscribePlan.xid,
			plan_type: props.planType,
		});

		const otpCode = ref({
			verification_code: "",
			transcationID: null
		});

		const transOtp = ref({
			otp: "",
			transcationID: null,
			bindID: null
		});

		const rules = ref({});
		const loading = ref(false);
		const errorText = ref("");

		onBeforeMount(() => {
			const stripePromise = loadStripe(paymoKey.value);
			stripePromise.then(() => {
				paymoLoaded.value = true;
			});
		});

		// const closeModal = (reloadPage) => {
		//     emit("closed", reloadPage);
		// };

		// const onClose = () => {
		//     closeModal(false);
		// };

		const pay = () => {
			loading.value = true;
			var formError = false;
			rules.value = {};
			errorText.value = "";

			if (!formError) {
				// Submitting Form with payment token

				// emit("success", true);
				// swal({
				// 	title: "Good job!",
				// 	text: "You clicked the button!",
				// 	icon: "success",
				// 	button: "Aww yiss!",
				// });

				axiosAdmin
					.post("paymo-payment", {
						cardNumber: formData.value.cardNumber,
						expirationDate: formData.value.expirationDate,
						plan_id: formData.value.plan_id,
						plan_type: formData.value.plan_type
					})
					.then((response) => {
						console.log(response);

						if (response.data.cardStatus) {

							CardStatus.value = true;
							CardReadonly.value = true;
							finishButton.value = true;

							transOtp.value.transcationID = response.data.transaction_id;
							transOtp.value.bindID = response.data.bindID;

						}

						// finishButton.value = true;

						loading.value = false;
					}).catch(errorResponse => {
						console.log(errorResponse);

						var err = errorResponse.data;
						const errorCode = errorResponse.status;

						if (errorCode == 422) {
							var errorRules = {};
							if (err.error && typeof err.error.details != "undefined") {
								var keys = Object.keys(err.error.details);
								for (var i = 0; i < keys.length; i++) {
									var key = keys[i].replace(".", "\\.");

									errorRules[key] = {
										required: true,
										message: err.error.details[keys[i]][0],
									};
								}
							}

							rules.value = errorRules;
							message.error(t("common.fix_errors"));

						}

						loading.value = false;

					});
			}
		};

		const BindSuccess = () => {
			loading.value = true;
			rules.value = {};
			errorText.value = "";

			axiosAdmin
				.post("bind-card", {
					transaction_id: otpCode.value.transcationID,
					verification_code: otpCode.value.verification_code,
					plan_id: formData.value.plan_id,
					plan_type: formData.value.plan_type
				})
				.then((response) => {
					console.log(response);

					if (response.data.status) {
						CardStatus.value = true;
						finishButton.value = true;

						transOtp.value.transcationID = response.data.transaction_id;
						transOtp.value.bindID = response.data.bindID;
					}

					loading.value = false;

				}).catch(errorResponse => {

					console.log(errorResponse);

					var err = errorResponse.data;
					const errorCode = errorResponse.status;

					if (errorCode == 422) {
						var errorRules = {};
						if (err.error && typeof err.error.details != "undefined") {
							var keys = Object.keys(err.error.details);
							for (var i = 0; i < keys.length; i++) {
								var key = keys[i].replace(".", "\\.");

								errorRules[key] = {
									required: true,
									message: err.error.details[keys[i]][0],
								};
							}
						}

						rules.value = errorRules;
						message.error(t("common.fix_errors"));

					}

					loading.value = false;

				});
		};

		const confirmPAymo = () => {
			loading.value = true;
			rules.value = {};
			errorText.value = "";

			axiosAdmin
				.post("confirm-paymo", {
					transaction_id: transOtp.value.transcationID,
					otp: transOtp.value.otp,
					bindID: transOtp.value.bindID,
					plan_id: formData.value.plan_id,
					cardNumber: formData.value.cardNumber,
					plan_type: formData.value.plan_type
				})
				.then((response) => {
					console.log(response);

					loading.value = false;
					if (response.data.success) {

						message.success(response.data.message);
						emit("success", true);
					} else {
						errorText.value = response.data.message;
					}

				}).catch(errorResponse => {

					console.log(errorResponse);

					var err = errorResponse.data;
					const errorCode = errorResponse.status;

					if (errorCode == 422) {
						var errorRules = {};
						if (err.error && typeof err.error.details != "undefined") {
							var keys = Object.keys(err.error.details);
							for (var i = 0; i < keys.length; i++) {
								var key = keys[i].replace(".", "\\.");

								errorRules[key] = {
									required: true,
									message: err.error.details[keys[i]][0],
								};
							}
						}

						rules.value = errorRules;
						message.error(t("common.fix_errors"));

					}

					loading.value = false;

				});
		};

		return {
			// stripeKey,
			paymoKey,
			paymoLoaded,
			instanceOptions,
			elementsOptions,
			cardOptions,
			card,
			elms,
			pay,
			maskBindOtp,
			maskValue,
			maskCardNumber,
			maskCardYear,
			formData,
			rules,
			loading,
			errorText,
			maskotpCode,
			otpCode,
			finishButton,
			CardStatus,
			CardMessage,
			CardReadonly,
			BindSuccess,
			transOtp,
			confirmPAymo
		};
	},
};
</script>

<style></style>
