import {API_HOST} from "@/constants"
import axios from 'axios'

export const login = async (params = null) => {
    return await axios.post(API_HOST + "login", params);
}

export const register = async (params = null) => {
  return await axios.post(API_HOST + "register", params);
}
