import axiosClient from "../axios";

export function getUser({ commit }) {
    return axiosClient.get("/user").then(({ data }) => {
        commit("setUser", data.user);
        return data;
    });
}

export function login({ commit }, data) {
    return axiosClient.post("/login", data).then(({ data }) => {
        commit("setUser", data.user);
        commit("setToken", data.token);
        return data;
    });
}

export async function logout({ commit }) {
    try {
        const response = await axiosClient.post("/logout");
        commit("setToken", null); // Clear the token from the store
        return response; // Return the response if needed
    } catch (error) {
        console.error("Logout failed:", error); // Log the error for debugging
        throw error; // Re-throw the error for further handling
    }
}
export function getProducts(
    { commit },
    { url = null, search = "", perPage, sort_field, sort_direction } = {}
) {
    commit("setProducts", [true]);
    url = url || "/products";
    return axiosClient
        .get(url, {
            params: {
                search: search,
                per_page: perPage,
                sort_field: sort_field,
                sort_direction: sort_direction,
            },
        })

        .then((res) => {
            commit("setProducts", [false, res.data]);
        })
        .catch(() => {
            commit("setProducts", [false]);
        });
    // .then(({data}) => {
    //       debugger;
    //     commit('setProducts', [false, data]);
    //     return data;
    // })
}

export function getProduct({commit}, id) {
    return axiosClient.get(`/products/${id}`)
  }

 

export function createProduct({ commit }, product) {
    if (product.image instanceof File) {
        const form = new FormData();
        form.append("title", product.title);
        form.append("image", product.image);
        form.append("description", product.description);
        form.append("price", product.price);
        product = form;
    }
    return axiosClient.post("/products", product);
}
export function updateProduct({ commit }, product) {
    const id = product.id;

    let form = new FormData();
    form.append("id", product.id);
    form.append("title", product.title);
    form.append("description", product.description);
    form.append("price", product.price);
    form.append("_method", "PUT");

    // Append image only if it's a File instance
    if (product.image instanceof File) {
        form.append("image", product.image);
    }

    return axiosClient.post(`/products/${id}`, form, {
        headers: { "Content-Type": "multipart/form-data" },
    });
}


export function deleteProduct({ commit }, id) {
    return axiosClient.delete(`/products/${id}`)
    // .then(() => {
    //     commit("deleteProduct", id);
    // });
}
// export function deleteProduct({commit}, id) {
//   return axiosClient.delete(`/products/${id}`)
// }


// Orders Action

export function getOrder({commit}, id) {
    return axiosClient.get(`/orders/${id}`)
  }
  

export function getOrders(
    { commit },
    { url = null, search = "", perPage, sort_field, sort_direction } = {}
) {
    commit("setOrders", [true]);
    url = url || "/orders";
    return axiosClient
        .get(url, {
            params: {
                search: search,
                per_page: perPage,
                sort_field: sort_field,
                sort_direction: sort_direction,
            },
        })

        .then((res) => {
            commit("setOrders", [false, res.data]);
        })
        .catch(() => {
            commit("setOrders", [false]);
        });
    // .then(({data}) => {
    //       debugger;
    //     commit('setProducts', [false, data]);
    //     return data;
    // })
}

