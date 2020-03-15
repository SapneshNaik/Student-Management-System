// axios
import axios from 'axios'

const baseURL = "http://52.66.59.211/";
// const baseURL = "http://127.0.0.1/";

export default axios.create({
  baseURL: baseURL
  // You can add your headers here
})
