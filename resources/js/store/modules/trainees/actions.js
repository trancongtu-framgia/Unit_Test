export default {
    async getbatches () {
        const batchs = await axios.get('batches');

        return batchs.data;
    },

    async getRoles () {
        const roles = await axios.get('roles');

        return roles.data;
    },

    async register (context, data) {
        const user = await axios.post('trainees', {
            batch_id: data.batch_id,
            name: data.name,
            email: data.email,
            role_id: data.role_id,
            school: data.school
        })
        
        return user.data;
    }
}
