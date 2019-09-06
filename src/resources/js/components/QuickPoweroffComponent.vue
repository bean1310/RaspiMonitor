<template>
    <button type="button" class="btn btn-danger" name="quickReboot" @click="poweroff(true)">Force Poweroff</button>
</template>

<script>
    import {powerControlMixin} from '../mixin.js'

    export default {
        mixins: [powerControlMixin],
    };
</script>
