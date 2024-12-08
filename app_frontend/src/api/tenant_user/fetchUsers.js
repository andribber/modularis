import axios from 'axios';

export default async function(tenant_id) {
  const url_params = new URLSearchParams({ include: 'user' });

  const { data } = await axios.get(`tenants/${tenant_id}/users`, { params: url_params });

  return data;
}
