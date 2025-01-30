
const state = {
    user: {
         token: sessionStorage.getItem('TOKEN'),
         data: {}
    },
    products: {
        loading: true,
        data: []
    }
}
export default state
