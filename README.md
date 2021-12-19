# 設計文件

## 檔案

### /routes/api.php

api路由設定

---

### /app/Lib

系統共用 Library 放置之資料夾

---

### /app/Lib/Currency.php

貨幣物件
存有金額、幣種、匯率資料
提供換匯、格式化金額功能

---

### /app/Controller/ExchangeRateController.php

API Controller
負責取得匯率後創建貨幣物件
返回換匯並格式化後的資料

## API

### 匯率 API

```plaintext
GET /api/deposit/create
```

計算換匯後之金額並格式化
換匯後金額會四捨五入至 **小數點第二位** 並帶有 **千分位**

| 欄位         | 型態   | 必填 | 說明                                |
| ------------ | ------ | ---- | ----------------------------------- |
| fromCurrency | string | V    | 來源幣別 台幣:TWD 美金:USD 日元:JPY |
| toCurrency   | string | V    | 目標幣別 台幣:TWD 美金:USD 日元:JPY |
| amount       | int    | V    | 轉換前金額數字                      |

Response example:

```json
{
    "toAmount": "11,180.10"
}
```

| 欄位       | 型態   | 說明       |
| ---------- | ------ | ---------- |
| `toAmount` | string | 換匯後金額 |


## 測試

```php artisan test```

執行所有測試