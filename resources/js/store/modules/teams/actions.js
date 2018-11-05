export default {
    async addTeam(context, data) {
        axios.post('/teams', {
            name: data.name
        })
    },

    async getTeam () {
        const teams = await axios.get('teams');

        return teams.data
    },

    async deleteTeam (context, data) {
        axios.delete('teams/' + data.id)
    },

    async editTeam (context, data) {
        axios.put('teams/' + data.id, {
            name: data.name,
            id: data.id
        })
    }
}
