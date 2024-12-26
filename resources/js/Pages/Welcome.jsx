import { Head, Link } from "@inertiajs/react";
import axios from "axios";

export default function Welcome({ auth, products }) {
    const handelAddToCart = async (id) => {
        axios
            .post(route("api.add.to.cart", id))
            .then(function (response) {
                alert(response.data.message);
            })
            .catch(function (error) {
                alert(response.data.message);
            });
    };
    return (
        <div className="mx-auto w-[80%] ">
            <Head title="Products" />

            <div className="flex justify-between items-center">
                <h1 className="text-center text-4xl font-bold mt-10">
                    Product
                </h1>
                <Link href={route("cart")}>
                    <span className="px-4 py-1 bg-black text-white rounded-md">
                        Cart
                    </span>
                </Link>
            </div>
            <div className="grid grid-cols-1 sm:grid-cols-2  md:grid-cols-3 gap-x-4">
                {products.length > 0 ? (
                    products.map((product) => (
                        <div className="border p-3  mt-10" key={product.id}>
                            <img
                                src={product.product_image}
                                alt={product.product_image}
                            />
                            <p>{product.product_name}</p>
                            <p>${product.price}</p>
                            <button
                                className="bg-black px-4 py-1 text-white rounded-md"
                                onClick={() => handelAddToCart(product.id)}
                            >
                                Add to cart
                            </button>
                        </div>
                    ))
                ) : (
                    <p>No products found</p>
                )}
            </div>
        </div>
    );
}
