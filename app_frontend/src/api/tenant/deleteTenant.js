import axios from 'axios';

export default async function(tenant_id) {
  await axios.delete(`tenants/${tenant_id}`);
}
