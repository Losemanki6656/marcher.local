require('./common/plugins');

window.Emoji = function () {
    var ranges = [
        '\u00a9|\u00ae|[\u2000-\u3300]|\ud83c[\ud000-\udfff]|\ud83d[\ud000-\udfff]|\ud83e[\ud000-\udfff]'
    ];

    function removeInvalidChars(str) {
        return str.replace(new RegExp(ranges.join('|'), 'g'), '');
    }

    document.querySelectorAll('input').forEach(function (element) {
        element.removeEventListener('blur', (e) => {
            console.log(1);
        });
        element.removeEventListener('focus', (e) => {
            console.log(1);
        });
        element.removeEventListener('input', (e) => {
            console.log(1);
        });
    });

    document.querySelectorAll('input').forEach(function (element) {
        element.addEventListener('input', (event) => {
            element.value = removeInvalidChars(event.target.value);
        });
    });
}

import { createApp } from 'vue';
import Antd from 'ant-design-vue';
import PerfectScrollbar from 'vue3-perfect-scrollbar';
import App from './main/views/App.vue';
import routes from './main/router'
import store from './main/store';
import { setupI18n, loadLocaleMessages } from './common/i18n';

import 'vue3-perfect-scrollbar/dist/vue3-perfect-scrollbar.css';
import VueBarcode from '@chenfengyuan/vue-barcode';
import print from 'vue3-print-nb';
import { VueRestrictedInputDirective } from 'vue-restricted-input';

import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
// import VueSimpleAlert from "vue-simple-alert";

// import AInput from './main/components/custom/AInput'


async function bootstrap() {
    if (store.getters["auth/isLoggedIn"]) {
        store.dispatch("auth/updateUser");
    }

    store.dispatch("auth/updateGlobalSetting");
    store.dispatch("auth/updateApp");
    store.dispatch("auth/updateAllLangs");
    store.dispatch("auth/updateAllWarehouses");
    store.commit("auth/updateActiveModules", window.config.modules);
    store.dispatch("auth/updateVisibleSubscriptionModules");

    const app = createApp(App);

    const i18n = setupI18n({ legacy: false, globalInjection: true, locale: store.state.auth.lang, warnHtmlMessage: false });
    await loadLocaleMessages(i18n, store.state.auth.lang);

    // app.config.devtools = true;
    // app.config.debug = true;

    app.use(i18n);
    app.use(Antd);
    app.use(PerfectScrollbar)
    app.use(store);
    app.use(print);
    app.use(VueSweetalert2);
    // app.use(VueSimpleAlert);


    // app.component('a-input', AInput);
    app.component(VueBarcode.name, VueBarcode);

    const allModules = window.config.installed_modules;

    allModules.forEach((allModule) => {
        const moduleName = allModule.verified_name;
        const pluginModule = require(`../../Modules/${moduleName}/Resources/assets/js/index`).default;

        app.use(pluginModule, { routes, store });
    });

    // Adding routes after plugins routes
    app.use(routes);
    app.directive('mask', VueRestrictedInputDirective);
    window.i18n = i18n;

    routes.isReady().then(() => {
        if (routes.currentRoute && routes.currentRoute.value && routes.currentRoute.value.meta && routes.currentRoute.value.meta.isFrontStore) {
            store.commit("front/updateWarehouseSlug", routes.currentRoute.value.params.warehouse);
            store.commit("front/updateWarehouseCurrency", window.config.warehouseCurrency);
            store.commit("front/updateApp", window.config.frontStoreSettings);
        }
        app.mount("#app");
    })

}

bootstrap();



