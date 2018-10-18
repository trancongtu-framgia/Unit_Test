export default {
    addWorkSpace(context, data) {
        axios.defaults.headers.common['Authorization'] =
            'Bearer ' + localStorage.getItem('access_token');

        axios.post('/workspaces', {
            name: data.name
        })
        .then(response => {
            
        })
        .catch(error => {
            console.log(error)
        })
    }
}
