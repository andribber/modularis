import axios from 'axios';

export default async function(tenant_id, module, body) {
  const { data } = await axios.post(`tenants/${tenant_id}/modules/${module}/attach-users`, body);

  return data;
}
