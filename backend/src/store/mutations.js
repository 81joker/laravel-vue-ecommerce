export function setUser(state, user) {
    state.user.data = user
}

export function setToken (state, token) {
    state.user.token = token
    if (token){
        sessionStorage.setItem('Token', token)
    } else {
        sessionStorage.removeItem('Token')
    }
}
