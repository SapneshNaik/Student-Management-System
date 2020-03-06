// axios
import axios from 'axios'

const baseURL = "http://13.234.238.99/";

export default axios.create({
  baseURL: baseURL
  // You can add your headers here
})
