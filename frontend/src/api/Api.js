import {API_HOST} from "@/constants"

import axios from "axios";

let Api = axios.create({
  baseURL: API_HOST
});

Api.defaults.withCredentials = true;

export default Api;
