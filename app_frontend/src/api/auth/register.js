import axios from 'axios';

export default async function(body) {
  const { data } = await axios.post('register', body);

  return data;
}
