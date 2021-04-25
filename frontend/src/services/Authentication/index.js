// import {API_HOST} from "@/constants"
import axios from 'axios'

export const login = async (credentials = null) => {
  return await axios.post("login", credentials);
}

export const register = async (credentials = null) => {
  return await axios.post("register", credentials);
}
