import axios from 'axios';

export default async function(tenant_id, body) {
  const { data } = await axios.put(`tenants/${tenant_id}`, body);

  return data;
}
