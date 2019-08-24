<template>
    <button type="submit" class="btn btn-warning" data-toggle="modal" data-target="#rebootModal" @click="reboot(false)">Reboot</button>
</template>

<script>
    import {powerControlMixin} from '../mixin.js'

    export default {
        mixins: [powerControlMixin],
    };
</script>
