export default {
    addTeam(context, data) {
        axios.defaults.headers.common['Authorization'] =
            'Bearer ' + localStorage.getItem('access_token');

        axios.post('/teams', {
            name: data.name
        })
        .then(response => {
            
        })
        .catch(error => {
            console.log(error)
        })
    }
}
