const state = {
    user: {
        token: sessionStorage.getItem("TOKEN"),
        data: {},
    },
    products: {
        loading: true,
        data: [],
        links: [],
        from: null,
        to: null,
        page: 1,
        limit: null,
        total: null,
    },
    orders: {
        loading: true,
        data: [],
        links: [],
        from: null,
        to: null,
        page: 1,
        limit: null,
        total: null,
    },
    toast: {
        show: false,
        message: "",
    },
    users: {
        loading: false,
        data: [],
        links: [],
        from: null,
        to: null,
        page: 1,
        limit: null,
        total: null
      },
    customers: {
        loading: false,
        data: [],
        links: [],
        from: null,
        to: null,
        page: 1,
        limit: null,
        total: null
      },
};
export default state;
