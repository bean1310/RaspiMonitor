export const powerControlMixin = {
    
    methods: {

        reboot(isQucik) {
            axios.post('/api/powerControl/reboot', {
                isQuick: isQucik,
            }).then((response) => {
                console.log(response.data)
            })
        },
        
        poweroff(isQucik) {
            axios.post('/api/powerControl/poweroff', {
                isQuick: isQucik,
            }).then((response) => {
                console.log(response.data)
            })
        },
        
        cancelShutdownProcess() {
            axios.post('/api/powerControl/cancel', {
            }).then((response) => {
                console.log(response.data)
            })
        },

    }
}