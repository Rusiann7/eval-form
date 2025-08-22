export const isAuthenticated = () => {
  const token = localStorage.getItem('token')
  return Boolean(token)
}

export const getToken = () => localStorage.getItem('token')

export const setToken = (token) => {
  localStorage.setItem('token', token)
}

export const removeToken = () => {
  localStorage.removeItem('token')
  localStorage.removeItem('userData')
}

export const getUserData = () => {
  const userData = localStorage.getItem('userData')
  return userData ? JSON.parse(userData) : null
}

export const setUserData = (data) => {
  localStorage.setItem('userData', JSON.stringify(data))
}
