<template>
    <button type="submit" class="btn btn-danger" data-toggle="modal" data-target="#poweroffModal" @click="poweroff(false)">Poweroff</button>
</template>

<script>
    import {powerControlMixin} from '../mixin.js'

    export default {
        mixins:[powerControlMixin],
    };
</script>
