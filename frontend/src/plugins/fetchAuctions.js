import axios from 'axios'

const fetchAuctions = async (path, type = 'active') => {
    return new Promise((resolve, reject) => {
        axios
        .get(path)
        .then(res => {          
            const {data:{data}} = res;
            let auctions;
            if (!data) {
                return
            } else if (data.length) {
                auctions = data
            } else {
                auctions = [data]
            }

            let charityAuctions;
            let commercialAuctions;
            if (type === 'active') {
                charityAuctions = auctions.find(auction => {
                    return auction.type === 'charity'
                });
    
                commercialAuctions = auctions.find(auction => {
                    return auction.type === 'commercial'
                });
            } else {
                charityAuctions = auctions.filter(auction => {
                    return auction.type === 'charity'
                });
    
                commercialAuctions = auctions.filter(auction => {
                    return auction.type === 'commercial'
                });
            }

            resolve({
                charityAuctions,
                commercialAuctions
            });
        })
        .catch(err => {
            console.log(`Error fetching active auctions: ${err}`)  
            reject({});        
        });
    });
}

export default fetchAuctions;