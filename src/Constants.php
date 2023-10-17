<?php

namespace Tinosoft\HotRecharge;
 class Constants {
     // Constants.php

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

    const ERROR = "Error: ";
}
