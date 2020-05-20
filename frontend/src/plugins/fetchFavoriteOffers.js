import axios from 'axios'

const fetchFavoriteOffers = async (userId) => {
    return new Promise((resolve, reject) => {
        axios
            .get(`http://127.0.0.1:8000/api/offers/favorites/${userId}`)
            .then(res => {
                resolve(res.data);
            })
            .catch(err => {
                console.log(err);      
                reject([]); 
            })
    })
  }

export default fetchFavoriteOffers;