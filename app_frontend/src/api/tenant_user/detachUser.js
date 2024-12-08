import axios from 'axios';

export default async function(tenant_id, user_id) {
  await axios.delete(`tenants/${tenant_id}/users/${user_id}`);
}
