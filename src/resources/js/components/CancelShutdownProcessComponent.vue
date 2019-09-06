<template>
<button type="button" class="btn btn-secondary" data-dismiss="modal" @click="cancelShutdownProcess()">Cancel</button>
</template>

<script>
    import {powerControlMixin} from '../mixin.js'

    export default {
        mixins: [powerControlMixin],
    };
</script>
