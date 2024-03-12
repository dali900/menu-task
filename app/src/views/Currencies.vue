<script setup>
import { ref, reactive, computed, watch, onMounted, onUnmounted, onBeforeMount } from 'vue'
import { storeToRefs } from 'pinia'
import { useCurrencyStore } from '../stores/currency.js'

const currencyStore = useCurrencyStore();
const { currencies, calculations, apiErrorMsg, loading } = storeToRefs(currencyStore);

const selectedCurrency = ref(null);
const amount = ref(null);
const orderData = ref(null);
const formError = ref(null);
const purchaseMessage = ref(null);

onBeforeMount( () => {
    currencyStore.getCurrencies();
});

const fetchQuote = () => {
    formError.value = null;
    if (!selectedCurrency.value || !amount.value) {
        formError.value = "Please provdide all required fields."    
    } else if (isNaN(amount.value)) {
        formError.value = "Amount is not a number."
    } else {
        currencyStore.getQuote(selectedCurrency.value, amount.value)
    }
}

watch([selectedCurrency, amount], ([newX, newY]) => {
    currencyStore.calculations = null;
})


const purchaseCurrency = () => {
    let payload = {
        amount: amount.value
    };
    currencyStore.purchase(selectedCurrency.value, payload)
        .then((responseData) => {
            console.log(responseData);
            if (responseData.order) {
                orderData.value = responseData.order;
                purchaseMessage.value = "Order created!";
            }
        }) 
}

const purchaseMore = () => {
    orderData.value = null;
    selectedCurrency.value = null;
    amount.value = null;
    purchaseMessage.value = null;
}
</script>

<template>
    <div class="currencies" v-if="!orderData">
        <h1>Currency exchange</h1>
        <div v-if="currencies && currencies.length" class="fields">
            <div>
                <label for="currencies">Select currency *</label>
                <div>
                    <select v-model="selectedCurrency" class="currencies-dropdown" id="currencies">
                        <option v-for="(currency, index) in currencies" :key="index" :value="currency.code">{{ currency.code +" - "+ currency.name }}</option>
                    </select>
                </div>
            </div>
            <div>
                <label for="amount">Amount <span v-if="selectedCurrency">({{ selectedCurrency }})</span> *</label>
                <div>
                    <input v-model="amount" type="text" class="qoute-amount-field" id="amount"/>
                </div>
            </div>
            <div>
                <button class="btn" @click="fetchQuote">Get Quote</button>
            </div>
        </div>
        <div v-else>No currencies</div>
        <div class="error-msg">
            {{ formError }}
        </div>
        <div class="error-msg">
            {{ apiErrorMsg }}
        </div>
        <div class="calculations" v-if="calculations">
            <h2>Quote</h2>
            <table class="quote-table">
                <tr>
                    <td class="right">Amount:</td>
                    <td class="left">{{ calculations.amount }}</td>
                </tr>
                <tr>
                    <td class="right">Surcharge amount:</td>
                    <td class="left">{{ calculations.surcharge_amount }}</td>
                </tr>
                <tr>
                    <td class="right">Total amount:</td>
                    <td class="left">{{ calculations.total_amount }}</td>
                </tr>
            </table>
            <div>
                <button class="btn" @click="purchaseCurrency">Purchase</button>
            </div>
        </div>
        <div v-if="loading">
            <h4>Please wait...</h4>
        </div>
    </div>
    <div v-else>
        <h2 class="purchase-msg">{{ purchaseMessage }}</h2>
        <div>
            <table class="order-table">
                <tr>
                    <td class="right">Amount purchased:</td>
                    <td class="left">{{ orderData.amount_purchased }}</td>
                </tr>
                <tr>
                    <td class="right">Exchange rate:</td>
                    <td class="left">{{ orderData.exchange_rate }}</td>
                </tr>
                <tr>
                    <td class="right">Surcharge percentage:</td>
                    <td class="left">{{ orderData.surcharge_percentage }}%</td>
                </tr>
                <tr>
                    <td class="right">Surcharge amount:</td>
                    <td class="left">{{ orderData.surcharge_amount }}</td>
                </tr>
                <tr>
                    <td class="right">Total amount:</td>
                    <td class="left">{{ orderData.total_amount_usd }}</td>
                </tr>
                <tr>
                    <td class="right">Discount percentage:</td>
                    <td class="left">{{ orderData.discount_percentage }}%</td>
                </tr>
                <tr>
                    <td class="right">Discount amount:</td>
                    <td class="left">{{ orderData.discount_amount }}</td>
                </tr>
                <tr>
                    <td class="right">Final payment:</td>
                    <td class="left">{{ orderData.amount_paid_usd }}</td>
                </tr>
            </table>
        </div>
        <div>
            <button class="btn" @click="purchaseMore">Purchase more</button>
        </div>
    </div>
</template>

<style scoped>
.fields {
    display: flex;
    align-items: end;
    gap: 8px;
}
.currencies-dropdown {
    padding: 8px;
}
.btn {
    padding: 8px 4px;
}
.qoute-amount-field {
    padding: 8px 4px;
}
.error-msg {
    color: red;
}
.right {
    text-align: right;
}
.left {
    text-align: left;
}
.purchase-msg {
    color: darkgreen;
}
</style>
