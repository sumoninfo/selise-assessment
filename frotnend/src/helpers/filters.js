const filters = {
    withCurrency(input) {
        if (isNaN(input)) {
            return "-";
        }
        return process.env.VUE_APP_WITH_CURRENCY + input.toFixed(2);
    }
}
export default filters;
