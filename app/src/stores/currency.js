
import { http } from '@/util/apiClient';
import { defineStore } from 'pinia'

export const useCurrencyStore = defineStore('currency', {
    state: () => ({
        currencies: [],
        calculations: null,
        order: null,
        loading: false,
        apiErrorMsg: null
    }),
    actions: {
        async getCurrencies(){
            this.apiErrorMsg = null;
            this.loading = true;
            try {
                const response = await http.get('currencies/');
                this.loading = false;
                this.currencies = response.data.currencies;
                return response.data;
            } catch (error) {
                this.loading = false;
                const response = error.response;
                this.apiErrorMsg = response?.data.message;
            }
        }, 
        async getQuote(code, amount){
            this.apiErrorMsg = null;
            this.loading = true;
            try {
                const response = await http.get('currencies/quote/'+code+'/'+amount);
                this.loading = false;
                this.calculations = response.data.calculations;
                return response.data;
            } catch (error) {
                this.loading = false;
                const response = error.response;
                this.apiErrorMsg = response?.data.message;
            }
        }, 
        async purchase(code, payload){
            this.apiErrorMsg = null;
            this.loading = true;
            try {
                const response = await http.post('orders/'+code, payload);
                this.loading = false;
                this.order = response.data.order;
                return response.data;
            } catch (error) {
                this.loading = false;
                const response = error.response;
                this.apiErrorMsg = response?.data.message;
            }
        }, 
       
    }
});
