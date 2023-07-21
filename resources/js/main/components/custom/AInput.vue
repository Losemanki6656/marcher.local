<template>
    <input type="text" class="ant-input" pattern="[a-zA-Z\s&\d]" v-model="inputVal">
</template>

<script>
export default {
    props: ['value'],
    computed: {
        inputVal: {
            get() {
                return this.value;
            },
            set(val) {
                this.$emit('input', val);
            }
        }
    }
};
</script>
