import axiosClient from "@/axios";

export function login({ commit},data) {
    console.log(data);

 return axiosClient.post("/login", {data})
    .then(({data}) => {
        commit("setUser", data.user);
        commit("setToken", data.token);
        return data;
    })
    .catch(({response}) => {
        throw new Error(response.data.message);
    });
}

export async function logout({ commit }) {
    try {
        const response = await axiosClient.post("/logout");
         commit('setToken', null);
        // OR
        commit("setUser", {});
        // commit("setToken", null);
        return response;
    } catch ({ response }) {
        throw new Error(response.data.message);
    }
}
