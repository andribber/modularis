import axios from 'axios';

export default async function(body) {
  const { data } = await axios.post('login', body);

  return data;
}
