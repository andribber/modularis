import axios from 'axios';
import { clearStores } from '../../helpers/clearStores';

export default async function() {
  await axios.get('logout');

  clearStores();
}
