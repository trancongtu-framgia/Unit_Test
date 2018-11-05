export default {
    async addType (context, data) {
        await axios.post('/types', {
            name: data.name,
            shorthand: data.shorthand
        })
    },

    async getType (context, data) {
        const types = await axios.get('types');

        return types.data;
    },

    async editType (context, data) {
        var obj = {};
        var key = data.column;
        obj[key] = data.type;
        await axios({
            method: 'patch', 
            url: 'types/' + data.id,
            data: obj
        });
    },

    async deleteType (context, data) {
        await axios.delete('/types/' + data.id)
    }
}
