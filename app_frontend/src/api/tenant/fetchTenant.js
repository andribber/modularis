import axios from 'axios';

export default async function(tenant_id) {
  const { data } = await axios.get(`tenants/${tenant_id}`);

  return data;
}
