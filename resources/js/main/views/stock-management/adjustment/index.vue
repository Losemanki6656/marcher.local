<template>
    <AdminPageHeader>
        <template #header>
            <a-page-header :title="$t(`menu.stock_adjustment`)" class="p-0">
                <template v-if="permsArray.includes('stock_adjustments_create') ||
                    permsArray.includes('admin')
                    " #extra>
                    <a-button type="primary" @click="addItem">
                        <PlusOutlined />
                        {{ $t("stock_adjustment.add") }}
                    </a-button>
                </template>
            </a-page-header>
        </template>
        <template #breadcrumb>
            <a-breadcrumb separator="-" style="font-size: 12px">
                <a-breadcrumb-item>
                    <router-link :to="{ name: 'admin.dashboard.index' }">
                        {{ $t(`menu.dashboard`) }}
                    </router-link>
                </a-breadcrumb-item>
                <a-breadcrumb-item>
                    {{ $t(`menu.stock_adjustment`) }}
                </a-breadcrumb-item>
            </a-breadcrumb>
        </template>
    </AdminPageHeader>

    <a-card class="page-content-container">
        <AddEdit :addEditType="addEditType" :visible="addEditVisible" :url="addEditUrl" @addEditSuccess="addEditSuccess"
            @closed="onCloseAddEdit" :formData="formData" :data="viewData" :pageTitle="pageTitle"
            :successMessage="successMessage" />

        <a-row style="mb-20" :gutter="[15, 15]">
            <a-col :xs="24" :sm="24" :md="8" :lg="4" :xl="4">
                <ProductSearchInput @valueChanged="(productId) => {
                    filters.product_id = productId;
                    reFetchDatatable();
                }
                    " />
            </a-col>
            <!-- <a-col :xs="24" :sm="24" :md="8" :lg="4" :xl="4">
                <CategorySearchInput @valueChanged="(categoryId) => {
                    filters.category_id = categoryId;
                    reFetchDatatable();
                }
                    " />
            </a-col>
            <a-col :xs="24" :sm="24" :md="8" :lg="6" :xl="4">
                <a-input-search v-model:value="table.searchString" show-search @change="onTableSearch"
                    @search="onTableSearch" style="width: 100%" :loading="table.filterLoading"
                    :placeholder="$t('common.search')" />
            </a-col> -->
        </a-row>

        <a-row class="mt-20">
            <a-col :span="24">
                <div class="table-responsive">
                    <a-table :columns="columns" :row-key="(record) => record.xid" :data-source="table.data"
                        :pagination="table.pagination" :loading="table.loading" @change="handleTableChange">
                        <template #bodyCell="{ column, record }">
                            <template v-if="column.dataIndex === 'product_id'">
                                <a-badge>
                                    <a-avatar shape="square" :src="record.product.image_url" />
                                    {{ record.product.name }}
                                </a-badge>
                            </template>
                            <template v-if="column.dataIndex === 'category'">
                                {{ record.product.category ? record.product.category.name : "-" }}
                            </template>
                            <template v-if="column.dataIndex === 'barcode_symbology'">
                                {{ record.product.barcode_symbology }}
                            </template>
                            <template v-if="column.dataIndex === 'purchase_price'">
                                {{ record.product.details.purchase_price }}
                            </template>
                            <template v-if="column.dataIndex === 'sales_price'">
                                {{ record.product.details.sales_price }}
                            </template>
                            <template v-if="column.dataIndex === 'current_stock'">
                                {{ record.product.details.current_stock }}
                            </template>
                            <template v-if="column.dataIndex === 'quantity'">
                                <a-typography-text v-if="record.adjustment_type == 'add'" type="success" strong>
                                    +{{ record.quantity }}
                                </a-typography-text>
                                <a-typography-text v-else type="danger" strong>
                                    -{{ record.quantity }}
                                </a-typography-text>
                            </template>
                            <template v-if="column.dataIndex === 'action'">
                                <a-button v-if="permsArray.includes('stock_adjustments_edit') ||
                                    permsArray.includes('admin')
                                    " type="primary" @click="editItem(record)" style="margin-left: 4px">
                                    <template #icon>
                                        <EditOutlined />
                                    </template>
                                </a-button>
                                <a-button v-if="permsArray.includes('stock_adjustments_delete') ||
                                    permsArray.includes('admin')
                                    " type="primary" @click="showDeleteConfirm(record.xid)" style="margin-left: 4px">
                                    <template #icon>
                                        <DeleteOutlined />
                                    </template>
                                </a-button>
                            </template>
                        </template>
                    </a-table>
                </div>
            </a-col>
        </a-row>
    </a-card>
</template>
<script>
import { onMounted, watch } from "vue";
import { PlusOutlined, EditOutlined, DeleteOutlined } from "@ant-design/icons-vue";
import crud from "../../../../common/composable/crud";
import common from "../../../../common/composable/common";
import ProductSearchInput from "../../../../common/components/product/ProductSearchInput.vue";
import CategorySearchInput from "../../../../common/components/product/CategorySearchInput.vue";
import fields from "./fields";
import AddEdit from "./AddEdit.vue";
import AdminPageHeader from "../../../../common/layouts/AdminPageHeader.vue";

export default {
    components: {
        PlusOutlined,
        EditOutlined,
        DeleteOutlined,
        AddEdit,
        ProductSearchInput,
        CategorySearchInput,
        AdminPageHeader,
    },
    setup() {
        const { url, addEditUrl, hashableColumns, initData, columns, filters, filterableColumns } = fields();
        const crudVariables = crud();
        const { permsArray, selectedWarehouse } = common();

        onMounted(() => {
            crudVariables.crudUrl.value = addEditUrl;
            crudVariables.langKey.value = "stock_adjustment";
            crudVariables.initData.value = { ...initData };
            crudVariables.formData.value = { ...initData };
            crudVariables.hashableColumns.value = [...hashableColumns];

            reFetchDatatable();
        });

        const reFetchDatatable = () => {
            crudVariables.tableUrl.value = {
                url,
                filters,
            };

            crudVariables.table.filterableColumns = filterableColumns;

            crudVariables.fetch({
                page: 1,
            });
        };

        watch(selectedWarehouse, (newVal, oldVal) => {
            reFetchDatatable();
        });

        return {
            columns,
            permsArray,
            ...crudVariables,

            filters,
            reFetchDatatable,
        };
    },
};
</script>
