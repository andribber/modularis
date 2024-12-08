import axios from 'axios';

export default async function(tenant_id, body) {
  const { data } = await axios.post(`tenants/${tenant_id}/users`, body);

  return data;
}
