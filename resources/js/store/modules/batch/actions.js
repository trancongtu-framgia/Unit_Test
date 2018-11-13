export default {
    async addBatch (context, data) {
        const batch = await axios.post('/batches', {
            workspace_id: data.workspace_id,
            team_id: data.team_id,
            type_id: data.type_id,
            subject_ids: data.subject_ids,
            start_day: data.start_day,
            stop_day: data.stop_day,
        })

        return batch
    },

    async getbatches (context, data) {
        const batches = await axios.get('batches');

        return batches.data;
    },

    async getbatch (context, data) {
        const batch = await axios.get(`batches/${data.id_batch}`)

        return batch.data        
    },

    async editBatch (context, data) {
        const batch = await axios.put(`batches/${data.id}`, {
            workspace_id: data.workspace_id,
            team_id: data.team_id,
            type_id: data.type_id,
            subject_ids: data.subject_ids,
            start_day: data.start_day,
            stop_day: data.stop_day,
        });

        return batch
    },

    async deletebatches (context, data) {
        await axios.delete('/batches/' + data.id)
    }
}
