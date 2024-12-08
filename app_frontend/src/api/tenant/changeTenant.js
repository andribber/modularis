import axios from 'axios';

import { clearStores } from '../../helpers/clearStores';

export default async function(tenant_id) {
  const { data } = await axios.post(`tenants/${tenant_id}/tokens`);

  return data;
}
