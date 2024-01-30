<?php

namespace Tinosoft\HotRecharge;
 class HotRechargeConstants {
     // HotRechargeConstants.php

     const BASE_URL = 'https://ssl.hot.co.zw/api/v1/';
     const MIME_TYPES = "application/json";
    // Endpoints definition
    const RECHARGE_PINLESS = "agents/recharge-pinless";
    const RECHARGE_DATA = "agents/recharge-data";
    const WALLET_BALANCE = "agents/wallet-balance";
    const GET_DATA_BUNDLE = "agents/get-data-bundles";
    const ENDUSER_BALANCE = "agents/enduser-balance?targetmobile=";
    const QUERY_TRANSACTION = "agents/query-transaction?agentReference=";
    const QUERY_ZESA = "agents/query-zesa-transaction";
    const RECHARGE_ZESA = "agents/recharge-zesa";
    const ZESA_CUSTOMER = "agents/check-customer-zesa";
    const ZESA_BALANCE = "agents/wallet-balance-zesa";
    const QUERY_EVD = "agents/query-evd";
    const RECHARGE_EVD = "agents/recharge-evd";
    const BULK_EVD = "agents/bulk-evd";
    const BULK_TELONE_EVD = "agents/bulk-telone-evd";
    const RECHARGE_TELONE_ADSL = "agents/recharge-telone-adsl";
    const VERIFY_TELONE_ACCOUNT = "agents/verify-telone-account";
    const QUERY_TELONE_BALANCE = "agents/query-telone-balance";
    const PAY_TELONE_BILL = "agents/pay-telone-bill";
    const RECHARGE_TELONE_VOIP = "agents/recharge-telone-voip";
    const WALLET_BALANCE_USD = "agents/wallet-balance-usd";
     const RECHARGE_USD_EVD_PIN = "agents/recharge-evd-usd";
     const RECHARGE_DATA_USD = "agents/recharge-data-usd";

    const ERROR = "Error: ";
}
