<template>
    <div class="container">
        <div class="row mt-5">
            <div class="col-12">
                <passport-clients></passport-clients>
                <passport-authorized-clients></passport-authorized-clients>
                <passport-personal-access-tokens></passport-personal-access-tokens>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Developer mounted.')
        }
    }
</script>
