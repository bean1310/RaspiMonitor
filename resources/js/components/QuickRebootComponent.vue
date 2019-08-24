<template>
    <button type="button" class="btn btn-warning" name="quickReboot" @click="reboot(true)">Force Reboot</button>
</template>

<script>
    import {powerControlMixin} from '../mixin.js'

    export default {
        mixins: [powerControlMixin],
    };
</script>
