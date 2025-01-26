import axiosClient from "../axios";

export function getUser({commit}) {
  return axiosClient.get('/user')
    .then(({data}) => {
      commit('setUser', data.user);
      return data;
    })
}


export function login({commit}, data) {
  return axiosClient.post('/login', data)
    .then(({data}) => {
      commit('setUser', data.user);
      commit('setToken', data.token)
      return data;
    })
}


export async function logout({ commit }) {
    try {
      const response = await axiosClient.post('/logout');
      commit('setToken', null); // Clear the token from the store
      return response; // Return the response if needed
    } catch (error) {
      console.error('Logout failed:', error); // Log the error for debugging
      throw error; // Re-throw the error for further handling
    }
  }

