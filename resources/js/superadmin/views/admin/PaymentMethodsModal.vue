<template>
    <a-modal
        :visible="visible"
        :maskClosable="false"
        @cancel="onClose"
        :title="
            selectedPaymentMethod == ''
                ? $t('subscription_plans.upgrade_plan')
                : `${$t('subscription_plans.upgrade_plan')} - ${$t(
                      `menu.${selectedPaymentMethod}`
                  )}`
        "
        :footer="null"
    >
        <GoBack
            :visible="showPaymentButtons"
            @clicked="() => (showPaymentButtons = true, showOfflineMenu = false, showPaymoMenu = false)"
        />

        <PlanDetails
            :planType="planType"
            :subscribePlan="subscribePlan"
            :currency="currency"
        />

        <a-divider></a-divider>

        <div
            v-if="
                responseData &&
                responseData.offline_payment_modes &&
                responseData.offline_payment_modes.length > 0
            "
        >
            <a-row :gutter="16" justify="center" v-if="showPaymentButtons">
                <a-col :span="24">
                    <a-button @click="offlinePayment" type="primary" class="mb-20" block>
                        {{ $t(`offline_request.offline`) }}
                    </a-button>
                </a-col>
            </a-row>
            <div v-if="!showPaymentButtons && showOfflineMenu">
                <OfflineMethod
                    :allMethods="responseData.offline_payment_modes"
                    :subscribePlan="subscribePlan"
                    :planType="planType"
                    @success="offlinePaymentSuccess"
                />
            </div>
        </div>

        <div v-if="responseData && responseData.payment_methods">
            <div
                v-for="paymentMethod in responseData.payment_methods"
                :key="paymentMethod.xid"
            >
                <div
                    v-if="paymentMethod.status == 1 && paymentMethod.name_key == 'paymo'"
                >
                    <a-row :gutter="16" justify="center" v-if="showPaymentButtons">
                        <a-col :span="24">
                            <a-button
                                @click="makePayment(paymentMethod)"
                                type="primary"
                                class="mb-20"
                                block
                            >
                                {{ $t(`menu.${paymentMethod.name_key}`) }}
                            </a-button>
                        </a-col>
                    </a-row>

                    <div v-if="!showPaymentButtons && showPaymoMenu">
                        <PaymoGateway
                            v-if="
                                paymentMethod.name_key == 'paymo' &&
                                selectedPaymentMethod == 'paymo'
                            "
                            :paymentMethod="paymentMethod"
                            :subscribePlan="subscribePlan"
                            :planType="planType"
                            @success="closeModal"
                        />
                    </div>
                </div>
            </div>
        </div>
    </a-modal>
</template>

<script>
import { ref, onMounted } from "vue";
import PlanDetails from "./common/PlanDetails.vue";
import GoBack from "./common/GoBack.vue";
import StripeGateway from "./PaymentMethods/StripeGateway.vue";
import PaymoGateway from "./PaymentMethods/PaymoGateway.vue";
import PaypalGateway from "./PaymentMethods/PaypalGateway.vue";
import RazarpayGateway from "./PaymentMethods/RazarpayGateway.vue";
import OfflineMethod from "./PaymentMethods/OfflineMethod.vue";

export default {
    props: ["visible", "subscribePlan", "planType", "currency"],
    components: {
        StripeGateway,
        PaypalGateway,
        RazarpayGateway,
        OfflineMethod,
        PaymoGateway,
        PlanDetails,
        GoBack,
    },
    setup(props, { emit }) {
        const responseData = ref([]);
        const showPaymentButtons = ref(true);
        const showOfflineMenu = ref(false);
        const showPaymoMenu = ref(false);
        const selectedPaymentMethod = ref("");

        onMounted(() => {
            axiosAdmin.get("all-payment-methods").then((response) => {
                responseData.value = response.data;
                console.log(response.data);
            });
        });

        const makePayment = (payMethod) => {
            showPaymentButtons.value = false;
            showOfflineMenu.value = false;
            showPaymoMenu.value = true;
            selectedPaymentMethod.value = payMethod.name_key;
            // console.log(showPaymoMenu);
        };

        const offlinePayment = () => {
            showPaymentButtons.value = false;
            showOfflineMenu.value = true;
            // console.log(showOfflineMenu);
        };

        const offlinePaymentSuccess = (reloadPage) => {
            showPaymentButtons.value = true;
            selectedPaymentMethod.value = "";
            emit("offlinePaymentSuccess", reloadPage);
        };

        const closeModal = (reloadPage) => {
            showPaymentButtons.value = true;
            selectedPaymentMethod.value = "";
            emit("closed", reloadPage);
        };

        const onClose = () => {
            closeModal(false);
        };

        return {
            responseData,
            onClose,
            makePayment,
            showPaymoMenu,
            showOfflineMenu,
            showPaymentButtons,
            selectedPaymentMethod,

            offlinePayment,
            offlinePaymentSuccess,

            closeModal,
        };
    },
};
</script>
