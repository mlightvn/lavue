import * from "@constants"
import axios from 'axios'

export class AuthenticationLogin {
  async login(params = null) {
    return await axios.get(API_HOST + "login", params);
  }
}
