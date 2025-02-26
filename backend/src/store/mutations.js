export function setUser(state, user) {
    state.user.data = user
}

export function setToken (state, token) {
    state.user.token = token
    if (token){
        sessionStorage.setItem('TOKEN', token)
    } else {
        sessionStorage.removeItem('TOKEN')
    }
}

export function setProducts (state, [loading,response = null]) {
    if(response){
        state.products = {
          ...state.products,
            data:response.data,
            links: response.meta.links,
            from: response.meta.from,
            to: response.meta.to,
            page: response.meta.current_page,
            limit: response.meta.per_page,
            total: response.meta.total,
        }
        }
    state.products.loading = loading
    // state.products.data = response.data
}
// export function setProduct(state, product) {
//     state.product = { ...product, image: product.image || null };
//   }
// export function setProducts(state, [loading, data = null]) {

//     if (data) {
//       state.products = {
//         ...state.products,
//         data: data.data,
//         links: data.meta?.links,
//         page: data.meta.current_page,
//         limit: data.meta.per_page,
//         from: data.meta.from,
//         to: data.meta.to,
//         total: data.meta.total,
//       }
//     }
//     state.products.loading = loading;
//   }


// Set Orders
export function setOrders (state, [loading,response = null]) {
    if(response){
        state.orders = {
          ...state.orders,
            data:response.data,
            links: response.meta.links,
            from: response.meta.from,
            to: response.meta.to,
            page: response.meta.current_page,
            limit: response.meta.per_page,
            total: response.meta.total,
        }
        }
    state.orders.loading = loading
    // state.products.data = response.data
}


export function showToast(state, message) {
    state.toast.show = true;
    state.toast.message = message;
}
export function hideToast(state, message) {
    state.toast.show = true;
    state.toast.message = message;
}