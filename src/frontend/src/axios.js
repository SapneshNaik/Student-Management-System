// axios
import axios from 'axios'

const baseURL = "http://52.66.59.211/";

export default axios.create({
  baseURL: baseURL
  // You can add your headers here
})
