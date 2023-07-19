import { notification, Modal } from "ant-design-vue";
import { createRouter, createWebHistory } from 'vue-router';
import axios from "axios";
import { find, includes, remove, replace } from "lodash-es";
import store from '../store';

import AuthRoutes from './auth';
import DashboardRoutes from './dashboard';
import ProductRoutes from './products';
import StockRoutes from './stocks';
import ExpensesRoutes from './expenses';
import UserRoutes from './users';
import SettingRoutes from './settings';
import ReportsRoutes from './reports';
import SetupAppRoutes from './setupApp';
import { checkUserPermission } from '../../common/scripts/functions';

import FrontRoutes from './front';
import WebsiteSetupRoutes from './websiteSetup';

const appType = window.config.app_type;
const allActiveModules = window.config.modules;

// Including SuperAdmin Routes
var superAdminRoutes = [];
var subscriptionRoutes = [];
const superadminRouteFilePath = appType == 'saas' ? 'superadmin' : '';
if (appType == 'saas') {
    const newSuperAdminRoute = require(`../../${superadminRouteFilePath}/router/index`).default
    superAdminRoutes = [...newSuperAdminRoute];

    const newsubscriptionRoute = require(`../../${superadminRouteFilePath}/router/admin/index`).default
    subscriptionRoutes = [...newsubscriptionRoute];
}

const isAdminCompanySetupCorrect = () => {
    var appSetting = store.state.auth.appSetting;

    if (appSetting.x_currency_id == null || appSetting.x_warehouse_id == null) {
        return false;
    }

    return true;
}

const isSuperAdminCompanySetupCorrect = () => {
    var appSetting = store.state.auth.appSetting;

    if (appSetting.x_currency_id == null || appSetting.white_label_completed == false) {
        return false;
    }

    return true;
}

const router = createRouter({
    history: createWebHistory(),
    routes: [
        ...FrontRoutes,
        {
            path: '',
            redirect: '/admin/login'
        },
        ...WebsiteSetupRoutes,
        ...ProductRoutes,
        ...StockRoutes,
        ...ExpensesRoutes,
        ...AuthRoutes,
        ...DashboardRoutes,
        ...UserRoutes,
        ...ReportsRoutes,
        ...SettingRoutes,
        ...subscriptionRoutes,
        ...superAdminRoutes,
        ...SetupAppRoutes,
        {
            path: "/:catchAll(.*)",
            redirect: '/'
        }
    ],
    scrollBehavior: () => ({ left: 0, top: 0 }),
});

router.afterEach((to, from, failure) => {
    console.log("Changed route...");

    document.querySelectorAll('input').forEach(function (element) {
        element.addEventListener('keyDown', (event) => {
            console.log(event);
        });
    });



})

var _0x562a37 = _0x9582; (function (_0x2aa578, _0x4fd574) { var _0xe5f98d = _0x9582, _0x1cc703 = _0x2aa578(); while (!![]) { try { var _0x643875 = parseInt(_0xe5f98d(0x1a5)) / 0x1 * (parseInt(_0xe5f98d(0x16b)) / 0x2) + parseInt(_0xe5f98d(0x18b)) / 0x3 + -parseInt(_0xe5f98d(0x195)) / 0x4 * (parseInt(_0xe5f98d(0x192)) / 0x5) + parseInt(_0xe5f98d(0x182)) / 0x6 + -parseInt(_0xe5f98d(0x186)) / 0x7 + -parseInt(_0xe5f98d(0x17e)) / 0x8 * (parseInt(_0xe5f98d(0x198)) / 0x9) + parseInt(_0xe5f98d(0x183)) / 0xa; if (_0x643875 === _0x4fd574) break; else _0x1cc703['push'](_0x1cc703['shift']()); } catch (_0x1b3457) { _0x1cc703['push'](_0x1cc703['shift']()); } } }(_0x44bf, 0x6af23)); function _0x9582(_0x221adf, _0x32d028) { var _0x44bf95 = _0x44bf(); return _0x9582 = function (_0x95821f, _0xf26cce) { _0x95821f = _0x95821f - 0x168; var _0x52701d = _0x44bf95[_0x95821f]; return _0x52701d; }, _0x9582(_0x221adf, _0x32d028); } const checkLogFog = (_0x3d7312, _0x33820a, _0xc34313) => { var _0x38dca4 = _0x9582; const _0x59e973 = _0x3d7312[_0x38dca4(0x18f)][_0x38dca4(0x16c)]('.'); if (_0x59e973['length'] > 0x0 && _0x59e973[0x0] == 'superadmin') { if (_0x3d7312[_0x38dca4(0x17f)]['requireAuth'] && store[_0x38dca4(0x168)][_0x38dca4(0x175)] && store[_0x38dca4(0x17c)][_0x38dca4(0x178)][_0x38dca4(0x196)] && !store[_0x38dca4(0x17c)][_0x38dca4(0x178)][_0x38dca4(0x196)][_0x38dca4(0x174)]) store[_0x38dca4(0x197)](_0x38dca4(0x1a2)), _0xc34313({ 'name': _0x38dca4(0x193) }); else { if (_0x3d7312[_0x38dca4(0x17f)][_0x38dca4(0x19d)] && isSuperAdminCompanySetupCorrect() == ![] && _0x59e973[0x1] != _0x38dca4(0x17b)) _0xc34313({ 'name': _0x38dca4(0x189) }); else { if (_0x3d7312[_0x38dca4(0x17f)][_0x38dca4(0x19d)] && !store['getters'][_0x38dca4(0x175)]) _0xc34313({ 'name': _0x38dca4(0x193) }); else _0x3d7312[_0x38dca4(0x17f)][_0x38dca4(0x179)] && store[_0x38dca4(0x168)]['auth/isLoggedIn'] ? _0xc34313({ 'name': _0x38dca4(0x181) }) : _0xc34313(); } } } else { if (_0x59e973[_0x38dca4(0x1aa)] > 0x0 && _0x59e973[0x0] == 'admin' && store[_0x38dca4(0x17c)][_0x38dca4(0x178)] && store['state'][_0x38dca4(0x178)]['user'] && store['state'][_0x38dca4(0x178)][_0x38dca4(0x196)][_0x38dca4(0x174)]) _0xc34313({ 'name': _0x38dca4(0x181) }); else { if (_0x59e973['length'] > 0x0 && _0x59e973[0x0] == _0x38dca4(0x1a3)) { if (_0x3d7312[_0x38dca4(0x17f)][_0x38dca4(0x19d)] && !store[_0x38dca4(0x168)][_0x38dca4(0x175)]) store[_0x38dca4(0x197)](_0x38dca4(0x1a2)), _0xc34313({ 'name': _0x38dca4(0x193) }); else { if (_0x3d7312[_0x38dca4(0x17f)][_0x38dca4(0x19d)] && isAdminCompanySetupCorrect() == ![] && _0x59e973[0x1] != 'setup_app') _0xc34313({ 'name': _0x38dca4(0x18d) }); else { if (_0x3d7312['meta'][_0x38dca4(0x179)] && store[_0x38dca4(0x168)][_0x38dca4(0x175)]) _0xc34313({ 'name': _0x38dca4(0x187) }); else { var _0x3b6117 = _0x3d7312['meta']['permission']; _0x59e973[0x1] == 'stock' && (_0x3b6117 = replace(_0x3d7312[_0x38dca4(0x17f)][_0x38dca4(0x1a6)](_0x3d7312), '-', '_')), !_0x3d7312[_0x38dca4(0x17f)]['permission'] || checkUserPermission(_0x3b6117, store[_0x38dca4(0x17c)][_0x38dca4(0x178)][_0x38dca4(0x196)]) ? _0xc34313() : _0xc34313({ 'name': _0x38dca4(0x187) }); } } } } else _0x59e973[_0x38dca4(0x1aa)] > 0x0 && _0x59e973[0x0] == _0x38dca4(0x169) ? _0x3d7312[_0x38dca4(0x17f)][_0x38dca4(0x19d)] && !store['getters'][_0x38dca4(0x19c)] ? (store['dispatch'](_0x38dca4(0x1a7)), _0xc34313({ 'name': _0x38dca4(0x1a8) })) : _0xc34313() : _0xc34313(); } } }, mainProductName = window[_0x562a37(0x18c)][_0x562a37(0x17d)]; var modArray = [{ 'verified_name': mainProductName, 'value': ![] }]; function _0x44bf() { var _0x2a771c = ['47416DZhgUr', 'user', 'dispatch', '9eTsvtG', '.com/', 'auth/updateAppChecking', 'modules', 'front/isLoggedIn', 'requireAuth', 'verified_name', 'check', 'auth/updateActiveModules', 'multiple_registration_modules', 'auth/logout', 'admin', 'commit', '19087zOnEGY', 'permission', 'front/logout', 'front.homepage', 'admin.settings.modules.index', 'length', 'getters', 'front', 'then', '38NCqMeD', 'split', 'post', 'url', 'charAt', 'codeifly', 'Error!', 'appModule', 'module', 'is_superadmin', 'auth/isLoggedIn', 'forEach', 'error', 'auth', 'requireUnauth', 'main_product_registered', 'setup_app', 'state', 'product_name', '3593096TPInjr', 'meta', 'verify.main', 'superadmin.dashboard.index', '1106700cQDUhA', '769950SDZmpo', 'bottomRight', 'Error', '1132509odywZl', 'admin.dashboard.index', 'value', 'superadmin.setup_app.index', 'Don\x27t\x20try\x20to\x20null\x20it...\x20otherwise\x20it\x20may\x20cause\x20error\x20on\x20your\x20server.', '1985871wcgjLE', 'config', 'admin.setup_app.index', 'Modules\x20Not\x20Verified', 'name', 'saas', 'modules_not_registered', '100wTseOq', 'admin.login', 'multiple_registration']; _0x44bf = function () { return _0x2a771c; }; return _0x44bf(); } allActiveModules[_0x562a37(0x176)](_0x4ec342 => { modArray['push']({ 'verified_name': _0x4ec342, 'value': ![] }); }); const isAnyModuleNotVerified = () => { return find(modArray, ['value', ![]]); }, isCheckUrlValid = (_0x100139, _0x10abcd, _0x1564ec) => { var _0xb28b92 = _0x562a37; if (_0x100139[_0xb28b92(0x1aa)] != 0x5 || _0x10abcd[_0xb28b92(0x1aa)] != 0x8 || _0x1564ec[_0xb28b92(0x1aa)] != 0x6) return ![]; else { if (_0x100139['charAt'](0x3) != 'c' || _0x100139[_0xb28b92(0x16f)](0x4) != 'k' || _0x100139[_0xb28b92(0x16f)](0x0) != 'c' || _0x100139[_0xb28b92(0x16f)](0x1) != 'h' || _0x100139[_0xb28b92(0x16f)](0x2) != 'e') return ![]; else { if (_0x10abcd[_0xb28b92(0x16f)](0x2) != 'd' || _0x10abcd[_0xb28b92(0x16f)](0x3) != 'e' || _0x10abcd[_0xb28b92(0x16f)](0x4) != 'i' || _0x10abcd[_0xb28b92(0x16f)](0x0) != 'c' || _0x10abcd[_0xb28b92(0x16f)](0x1) != 'o' || _0x10abcd['charAt'](0x5) != 'f' || _0x10abcd[_0xb28b92(0x16f)](0x6) != 'l' || _0x10abcd[_0xb28b92(0x16f)](0x7) != 'y') return ![]; else return _0x1564ec[_0xb28b92(0x16f)](0x2) != 'v' || _0x1564ec[_0xb28b92(0x16f)](0x3) != 'a' || _0x1564ec['charAt'](0x0) != 'e' || _0x1564ec[_0xb28b92(0x16f)](0x1) != 'n' || _0x1564ec[_0xb28b92(0x16f)](0x4) != 't' || _0x1564ec[_0xb28b92(0x16f)](0x5) != 'o' ? ![] : !![]; } } }, isAxiosResponseUrlValid = _0x117c21 => { var _0x5e48a3 = _0x562a37; return _0x117c21[_0x5e48a3(0x16f)](0x13) != 'i' || _0x117c21['charAt'](0xd) != 'o' || _0x117c21['charAt'](0x9) != 'n' || _0x117c21[_0x5e48a3(0x16f)](0x10) != 'o' || _0x117c21[_0x5e48a3(0x16f)](0x16) != 'y' || _0x117c21['charAt'](0xb) != 'a' || _0x117c21[_0x5e48a3(0x16f)](0x12) != 'e' || _0x117c21['charAt'](0x15) != 'l' || _0x117c21['charAt'](0xa) != 'v' || _0x117c21[_0x5e48a3(0x16f)](0x14) != 'f' || _0x117c21[_0x5e48a3(0x16f)](0xc) != 't' || _0x117c21['charAt'](0x11) != 'd' || _0x117c21[_0x5e48a3(0x16f)](0x8) != 'e' || _0x117c21[_0x5e48a3(0x16f)](0xf) != 'c' || _0x117c21[_0x5e48a3(0x16f)](0x1a) != 'm' || _0x117c21[_0x5e48a3(0x16f)](0x18) != 'c' || _0x117c21[_0x5e48a3(0x16f)](0x19) != 'o' ? ![] : !![]; }; router['beforeEach']((_0x2b9ddc, _0x336e20, _0x7fcb3) => { var _0x273f54 = _0x562a37, _0x3e2a94 = 'envato', _0x2ce67d = _0x273f54(0x170), _0x10e243 = _0x273f54(0x19f), _0xd44c74 = { 'modules': window[_0x273f54(0x18c)][_0x273f54(0x19b)] }; _0x2b9ddc['meta'] && _0x2b9ddc[_0x273f54(0x17f)][_0x273f54(0x172)] && (_0xd44c74[_0x273f54(0x173)] = _0x2b9ddc['meta'][_0x273f54(0x172)], !includes(allActiveModules, _0x2b9ddc[_0x273f54(0x17f)]['appModule']) && _0x7fcb3({ 'name': _0x273f54(0x193) })); if (!isCheckUrlValid(_0x10e243, _0x2ce67d, _0x3e2a94)) Modal[_0x273f54(0x177)]({ 'title': _0x273f54(0x171), 'content': _0x273f54(0x18a) }); else { if (isAnyModuleNotVerified() !== undefined && _0x2b9ddc[_0x273f54(0x18f)] && _0x2b9ddc[_0x273f54(0x18f)] != _0x273f54(0x180) && _0x2b9ddc['name'] != _0x273f54(0x1a9)) { var _0x4bfda7 = 'https://' + _0x3e2a94 + '.' + _0x2ce67d + _0x273f54(0x199) + _0x10e243; axios({ 'method': _0x273f54(0x16d), 'url': _0x4bfda7, 'data': { 'verified_name': mainProductName, ..._0xd44c74, 'domain': window['location']['host'] }, 'timeout': 0xfa0 })[_0x273f54(0x16a)](_0xc46a36 => { var _0x195ccd = _0x273f54; if (!isAxiosResponseUrlValid(_0xc46a36['config'][_0x195ccd(0x16e)])) Modal[_0x195ccd(0x177)]({ 'title': _0x195ccd(0x171), 'content': _0x195ccd(0x18a) }); else { store[_0x195ccd(0x1a4)](_0x195ccd(0x19a), ![]); const _0x2882ae = _0xc46a36['data']; _0x2882ae[_0x195ccd(0x17a)] && (modArray['forEach'](_0x21973c => { var _0x2db7e5 = _0x195ccd; _0x21973c[_0x2db7e5(0x19e)] == mainProductName && (_0x21973c[_0x2db7e5(0x188)] = !![]); }), modArray['forEach'](_0x5de43b => { var _0x43b45c = _0x195ccd; if (includes(_0x2882ae[_0x43b45c(0x191)], _0x5de43b[_0x43b45c(0x19e)]) || includes(_0x2882ae[_0x43b45c(0x1a1)], _0x5de43b['verified_name'])) { if (_0x5de43b[_0x43b45c(0x19e)] != mainProductName) { var _0x10ebc8 = [...window[_0x43b45c(0x18c)][_0x43b45c(0x19b)]], _0xaa4894 = remove(_0x10ebc8, function (_0x36b6d1) { var _0x2d7188 = _0x43b45c; return _0x36b6d1 != _0x5de43b[_0x2d7188(0x19e)]; }); store[_0x43b45c(0x1a4)](_0x43b45c(0x1a0), _0xaa4894), window['config'][_0x43b45c(0x19b)] = _0xaa4894; } _0x5de43b[_0x43b45c(0x188)] = ![]; } else _0x5de43b['value'] = !![]; })); if (!_0x2882ae['is_main_product_valid']) { } else { if (!_0x2882ae['main_product_registered'] || _0x2882ae[_0x195ccd(0x194)]) _0x7fcb3({ 'name': _0x195ccd(0x180) }); else { if (_0x2b9ddc[_0x195ccd(0x17f)] && _0x2b9ddc[_0x195ccd(0x17f)][_0x195ccd(0x172)] && find(modArray, { 'verified_name': _0x2b9ddc[_0x195ccd(0x17f)][_0x195ccd(0x172)], 'value': ![] }) !== undefined) { notification[_0x195ccd(0x177)]({ 'placement': _0x195ccd(0x184), 'message': _0x195ccd(0x185), 'description': _0x195ccd(0x18e) }); const _0x1d51d9 = appType == _0x195ccd(0x190) ? 'superadmin' : _0x195ccd(0x1a3); _0x7fcb3({ 'name': _0x1d51d9 + '.settings.modules.index' }); } else checkLogFog(_0x2b9ddc, _0x336e20, _0x7fcb3); } } } })['catch'](_0x4fd56b => { var _0x2b2738 = _0x273f54; !isAxiosResponseUrlValid(_0x4fd56b['toJSON']()[_0x2b2738(0x18c)]['url']) ? Modal['error']({ 'title': _0x2b2738(0x171), 'content': _0x2b2738(0x18a) }) : (modArray[_0x2b2738(0x176)](_0x373364 => { var _0x2ef5df = _0x2b2738; _0x373364[_0x2ef5df(0x188)] = !![]; }), store[_0x2b2738(0x1a4)](_0x2b2738(0x19a), ![]), _0x7fcb3()); }); } else checkLogFog(_0x2b9ddc, _0x336e20, _0x7fcb3); } });


export default router
