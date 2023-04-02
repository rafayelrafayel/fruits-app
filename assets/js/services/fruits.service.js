import axios from 'axios';

const API_URL = '/api/fruits';

class FruitsService {
    getAll() {
        return axios.get(API_URL);
    }

    search(name, family, page = 1, limit = 10) {
        return axios.get(`${API_URL}?name=${name}&family=${family}&page=${page}&limit=${limit}`);
    }
}

export default new FruitsService();
