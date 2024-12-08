import axios from 'axios';

export default async function() {
  const { data } = await axios.get('me');

  return data;
}
