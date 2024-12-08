import axios from 'axios';

export default async function(tenant_id, user_id, body) {
  const { data } = await axios.patch(`tenants/${tenant_id}/users/${user_id}`, body);

  return data;
}
