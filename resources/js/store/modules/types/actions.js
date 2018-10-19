export default {
    addType(context, data) {
        axios.defaults.headers.common['Authorization'] =
            'Bearer ' + localStorage.getItem('access_token');

        axios.post('/types', {
            name: data.name,
            shorthand: data.shorthand
        })
        .then(response => {
            
        })
        .catch(error => {
            console.log(error)
        })
    }
}
