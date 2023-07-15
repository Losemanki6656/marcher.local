<template>
    <a-select v-model:value="searchTerm" show-search :filter-option="false"
        :placeholder="$t('common.select_default_text', [$t('product.category')])" style="width: 100%"
        :not-found-content="fetching ? undefined : null" @search="fetchcategories" option-label-prop="label"
        @change="valueChanged" :allowClear="true">
        <template #suffixIcon>
            <SearchOutlined />
        </template>
        <template v-if="fetching" #notFoundContent>
            <a-spin size="small" />
        </template>
        <a-select-option v-for="newProduct in categories" :key="newProduct.xid" :value="newProduct.xid"
            :label="newProduct.name" :product="newProduct">
            {{ newProduct.name }}
        </a-select-option>
    </a-select>
</template>

<script>
import { defineComponent, toRefs, reactive, watch, onMounted } from "vue";
import { SearchOutlined } from "@ant-design/icons-vue";
import { debounce } from "lodash-es";

export default defineComponent({
    props: ["productData"],
    emits: ["valueSuccess", "valueChanged"],
    components: {
        SearchOutlined,
    },
    setup(props, { emit }) {
        const state = reactive({
            searchTerm: [],
            fetching: false,
            categories: [],
        });

        onMounted(() => {
            resetSearchInput(props);
        });

        const resetSearchInput = (propVal) => {
            if (propVal.productData && propVal.productData.product) {
                state.categories = [
                    {
                        xid: propVal.productData.x_product_id,
                        name: propVal.productData.product.name,
                    },
                ];
                state.searchTerm = propVal.productData.x_product_id;
            } else {
                state.searchTerm = [];
                state.categories = [];
            }

            emit("valueSuccess");
        };

        const valueChanged = (value, option) => {
            emit("valueChanged", value);
            emit("valueSuccess");
        };

        const fetchcategories = debounce((value) => {
            state.categories = [];

            if (value != "") {
                state.fetching = true;
                const filterString = `name lk "%${value}%"`;
                let url = `categories?fields=xid,name&filters=${encodeURIComponent(
                    filterString
                )}&limit=10`;

                axiosAdmin.get(url).then((response) => {
                    state.categories = response.data;
                    state.fetching = false;
                });
            }
        }, 300);

        watch(props, (newVal, oldVal) => {
            resetSearchInput(newVal);
        });

        return {
            ...toRefs(state),
            fetchcategories,
            valueChanged,
        };
    },
});
</script>
