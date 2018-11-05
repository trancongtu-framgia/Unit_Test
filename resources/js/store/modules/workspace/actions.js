export default {
    addWorkSpace(context, data) {
        axios.post('/workspaces', {
            name: data.name
        })
        .then(response => {
            
        })
        .catch(error => {
            console.log(error)
        })
    },

    async getWorkspace (context) {
        const workspace = await axios.get('workspaces', {})
        
        return workspace.data
    },

    async editWorkspace (context, data) {
        const workspace = await axios.put('workspaces/' + data.id, {
            name: data.name,
            id: data.id
        })

        return workspace
    },

    async deleteWorkspace (context, data) {
        await axios.delete('workspaces/' + data.id)
    },

    async add (context, data) {
        await axios.post('workspaces/', {
            name: data.name
        })
    }
}
