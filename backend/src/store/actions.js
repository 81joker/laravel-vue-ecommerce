// import axiosClient from "@/axios";
import axiosClient from "../axios";

// export function getUser({commit}) {
//   return axiosClient.get('/user')
//     .then(({response}) => {
//       commit('setUser', response.data.user);
//       return response;
//     })
// }


export function login({commit}, data) {
  return axiosClient.post('/login', data)
    .then(({data}) => {
      commit('setUser', data.user);
      commit('setToken', data.token)
      return data;
    })
}


// export function logout({ commit }) {
//   return axiosClient.post('/logout', {}, {
//     headers: {
//       'Authorization': `Bearer ${store.state.token}`, // Assuming token is stored in Vuex
//     }
//   })
//   .then((response) => {
//     commit('setToken', null); // Clear token in Vuex
//     return response;
//   })
//   .catch((error) => {
//     console.error('Logout failed:', error);
//   });
// }

export function logout({commit}) {
  return axiosClient.post('/logout')
    .then((response) => {
      commit('setToken', null)

      return response;
    })
}

// export async function logout({ commit }) {
//     try {
//         const response = await axiosClient.post("/logout");
//          commit('setToken', null);
//          commit("setUser", {});
//          // OR
//         // commit("setToken", null);
//         return response;
//     } catch ({ error }) {
//         throw new Error(error);
//     }
// }
