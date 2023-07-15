import { reactive } from 'vue';
import { useI18n } from "vue-i18n";

const fields = () => {
    const addEditUrl = "stock-adjustments";
    const url = "stock-adjustments?fields=xid,product_id,x_product_id,product{id,xid,name,barcode_symbology,image,image_url},product:category{xid,name},product:details{purchase_price,sales_price,current_stock},quantity,adjustment_type";
    const hashableColumns = ['product_id'];
    const { t } = useI18n();

    const initData = {
        product_id: undefined,
        barcode_symbology: undefined,
        quantity: 1,
        notes: "",
        adjustment_type: "add",
    };

    const columns = [
        {
            title: t("product.product"),
            dataIndex: "product_id",
        },
        {
            title: t("product.category"),
            dataIndex: "category",
        },
        {
            title: t("product.barcode_symbology"),
            dataIndex: "barcode_symbology",
        },
        {
            title: t("product.purchase_price"),
            dataIndex: "purchase_price",
        },
        {
            title: t("product.sales_price"),
            dataIndex: "sales_price",
        },
        {
            title: t("product.current_stock"),
            dataIndex: "current_stock",
        },
        {
            title: t("stock_adjustment.quantity"),
            dataIndex: "quantity",
        },
        {
            title: t("common.action"),
            dataIndex: "action",
        },
    ];

    const adjustmentTypes = [
        {
            key: "add",
            value: t("stock_adjustment.adjustment_add"),
        },
        {
            key: "subtract",
            value: t("stock_adjustment.adjustment_subtract"),
        },
    ];

    const filters = reactive({
    });

    const filterableColumns = [
        {
            key: "quantity"
        }
    ];

    return {
        url,
        addEditUrl,
        hashableColumns,
        initData,
        columns,
        adjustmentTypes,
        filters,
        filterableColumns
    }
}

export default fields;
