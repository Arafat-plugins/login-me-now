import React, { useState, useEffect } from 'react';
import { Layout, Form, Input, Button, Select, Space, message, Upload, InputNumber, Checkbox, Switch } from 'antd';
import { UploadOutlined } from '@ant-design/icons';
import { __ } from '@wordpress/i18n';
import postData from '@helpers/postData';

const { Sider, Content } = Layout;
const { TextArea } = Input;

export default function Settings() {
  const [fields, setFields] = useState([]);
  const [loading, setLoading] = useState(true);
  const [form] = Form.useForm();
  const [activeTab, setActiveTab] = useState('general');

  useEffect(() => {
    setLoading(true);
    postData('login-me-now/admin/settings/fields')
      .then((data) => {
        setFields(data);
        const formData = data.reduce((acc, field) => {
          acc[field.id] = field.previous_data ?? (field.type === 'checkbox' || field.type === 'switch' ? false : '');
          return acc;
        }, {});
        form.setFieldsValue(formData);
      })
      .catch((error) => {
        message.error(__('Failed to load settings fields.', 'content-restriction'));
        console.error(error);
      })
      .finally(() => {
        setLoading(false);
      });
  }, [form]);

  const tabs = [
    { key: 'general', label: __('General', 'content-restriction') },
    { key: 'email-magic-link', label: __('Email Magic Link', 'content-restriction') },
    { key: 'advanced', label: __('Advanced', 'content-restriction') },
  ];

  const renderField = (field) => {
    if (field.tab !== activeTab) return null;

    const commonProps = {
      name: field.id,
      label: field.title,
      rules: [
        { required: true, message: `${field.title} is required.` },
        field.type === 'email' && { type: 'email', message: __('Invalid email format.', 'content-restriction') },
      ].filter(Boolean),
    };

    switch (field.type) {
      case 'text':
      case 'email':
        return (
          <Form.Item key={field.id} {...commonProps}>
            <Input placeholder={field.placeholder} className="border rounded-lg px-3 py-2 block h-[50px] !p-3 !border-slate-200 w-[70%] !mt-0" />
          </Form.Item>
        );
      case 'textarea':
        return (
          <Form.Item key={field.id} {...commonProps}>
            <TextArea placeholder={field.placeholder} rows={4} className="block h-[50px] !p-3 !border-slate-200 w-[70%] !mt-0" />
          </Form.Item>
        );
      case 'color':
        return (
          <Form.Item key={field.id} {...commonProps}>
            <Input type="color" className="w-16 h-10 border rounded-lg" />
          </Form.Item>
        );
      case 'file':
        return (
          <Form.Item key={field.id} {...commonProps}>
            <Upload beforeUpload={() => false} maxCount={1}>
              <Button icon={<UploadOutlined />} className="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
                {__('Upload File', 'content-restriction')}
              </Button>
            </Upload>
          </Form.Item>
        );
      case 'number':
        return (
          <Form.Item key={field.id} {...commonProps}>
            <InputNumber placeholder={field.placeholder} className="w-full border rounded-lg px-3 py-2" />
          </Form.Item>
        );
      case 'checkbox':
        return (
          <Form.Item key={field.id} name={field.id} valuePropName="checked" className="flex items-center space-x-2">
            <Checkbox>{field.description}</Checkbox>
          </Form.Item>
        );
      case 'switch':
        return (
          <Form.Item key={field.id} name={field.id} valuePropName="checked" className="flex items-center space-x-2">
            <Switch />
            <span>{field.title}</span>
          </Form.Item>
        );
      case 'select':
        return (
          <Form.Item key={field.id} {...commonProps}>
            <Select placeholder={field.placeholder} className="w-full">
              {field.options?.map((option) => (
                <Select.Option key={option.value} value={option.value}>
                  {option.label}
                </Select.Option>
              ))}
            </Select>
          </Form.Item>
        );
      default:
        return null;
    }
  };

  const handleSave = (values) => {
    postData('login-me-now/admin/settings/save', values)
      .then((response) => {
        if (!response.ok) {
          throw new Error(__('Failed to save settings.', 'content-restriction'));
        }
        return response.json();
      })
      .then(() => {
        message.success(__('Settings saved successfully!', 'content-restriction'));
      })
      .catch((error) => {
        message.error(__('Failed to save settings.', 'content-restriction'));
        console.error(error);
      });
  };

  return (
    <div className="max-w-3xl mx-auto px-6 lg:max-w-screen-2xl">
      <div className="mx-auto mt-10 mb-8 font-semibold text-2xl">
        Settings
      </div>

      <Layout className="mx-auto my-[2.43rem] bg-white rounded-md shadow overflow-hidden min-h-[36rem]">
        <Sider width={250} className="bg-gray-100 p-6">
          <ul className="space-y-2">
            {tabs.map((tab) => (
              <li
                key={tab.key}
                className={`p-2 rounded-lg cursor-pointer text-white ${activeTab === tab.key ? 'bg-blue-500' : 'hover:bg-gray-200 text-black'}`}
                onClick={() => setActiveTab(tab.key)}
              >
                {tab.label}
              </li>
            ))}
          </ul>
        </Sider>

        <Content className="p-10 w-full">
          <Form form={form} layout="vertical" onFinish={handleSave} disabled={loading}>
            <div className="grid grid-cols-1 gap-6">
              {fields.map((field) => renderField(field))}
            </div>
            <Form.Item className="mt-6">
              <Space>
                <Button type="primary" htmlType="submit" className="bg-blue-500 hover:bg-blue-600 text-white px-5 py-2 rounded-lg disabled:opacity-50">
                  {__('Save Settings', 'content-restriction')}
                </Button>
              </Space>
            </Form.Item>
          </Form>
        </Content>

      </Layout>
    </div>
  );
}
